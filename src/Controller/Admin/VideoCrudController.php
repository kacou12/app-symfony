<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use App\Admin\YanFied\YanFied;
use App\Form\FileUploadType;
use App\Service\FileUploader;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Form\Type\VichFileType;


class VideoCrudController extends AbstractCrudController
{
    public $file_uploader;
    public function __construct(FileUploader $file_uploader)
    {
        $this->file_uploader =  $file_uploader;
    }
    public static function getEntityFqcn(): string
    {
        return Video::class;
    }
    //yan add
    public function upload(UploadedFile $file): ?string
    {
        $file_name = $this->file_uploader->upload($file);
        if (null !== $file_name) // for example
        {
            $directory = $this->file_uploader->getTargetDirectory();
            $full_path = $directory . '/' . $file_name;
            // Do what you want with the full path file...
            // Why not read the content or parse it !!!
            return '/uploads/' . $file_name;
        } else {
            // Oups, an error occured !!!
        }
    }
    public function new(AdminContext $context)
    {
        $event = new BeforeCrudActionEvent($context);
        $this->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        if (!$this->isGranted(Permission::EA_EXECUTE_ACTION, ['action' => Action::NEW, 'entity' => null])) {
            throw new ForbiddenActionException($context);
        }

        if (!$context->getEntity()->isAccessible()) {
            throw new InsufficientEntityPermissionException($context);
        }

        $context->getEntity()->setInstance($this->createEntity($context->getEntity()->getFqcn()));
        $this->get(EntityFactory::class)->processFields($context->getEntity(), FieldCollection::new($this->configureFields(Crud::PAGE_NEW)));
        $this->get(EntityFactory::class)->processActions($context->getEntity(), $context->getCrud()->getActionsConfig());

        $newForm = $this->createNewForm($context->getEntity(), $context->getCrud()->getNewFormOptions(), $context);
        $newForm->handleRequest($context->getRequest());


        //yan form
        // $yan_form = $this->createForm(FileUploadType::class);
        // $yan_form->handleRequest($context->getRequest());

        $entityInstance = $newForm->getData();
        $context->getEntity()->setInstance($entityInstance);

        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $this->processUploadedFiles($newForm);

            //yan add
            $fileToUpload = $context->getRequest()->files->get('Video')['videoFile'];
            // dd($context->getRequest());
            $file_name = $this->upload($fileToUpload);


            $event = new BeforeEntityPersistedEvent($entityInstance);
            $this->get('event_dispatcher')->dispatch($event);
            $entityInstance = $event->getEntityInstance();

            if ($file_name != "") {
                $entityInstance->setUrl($file_name);
            }


            $this->persistEntity($this->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $entityInstance);

            $this->get('event_dispatcher')->dispatch(new AfterEntityPersistedEvent($entityInstance));
            $context->getEntity()->setInstance($entityInstance);

            $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];
            if (Action::SAVE_AND_CONTINUE === $submitButtonName) {
                $url = $this->get(AdminUrlGenerator::class)
                    ->setAction(Action::EDIT)
                    ->setEntityId($context->getEntity()->getPrimaryKeyValue())
                    ->generateUrl();

                return $this->redirect($url);
            }

            if (Action::SAVE_AND_RETURN === $submitButtonName) {
                $url = $context->getReferrer()
                    ?? $this->get(AdminUrlGenerator::class)->setAction(Action::INDEX)->generateUrl();

                return $this->redirect($url);
            }

            if (Action::SAVE_AND_ADD_ANOTHER === $submitButtonName) {
                $url = $this->get(AdminUrlGenerator::class)->setAction(Action::NEW)->generateUrl();

                return $this->redirect($url);
            }

            return $this->redirectToRoute($context->getDashboardRouteName());
        }

        $responseParameters = $this->configureResponseParameters(KeyValueStore::new([
            'pageName' => Crud::PAGE_NEW,
            'templateName' => 'crud/new',
            'entity' => $context->getEntity(),
            'new_form' => $newForm,
            // 'form' => $yan_form
        ]));

        $event = new AfterCrudActionEvent($context, $responseParameters);
        $this->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }
        return $responseParameters;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN')
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('title', "Titre")->setRequired(true),
            TextField::new('author', "auteur")->setRequired(true),
            TextField::new('content', "contenu")->setRequired(true),
            AssociationField::new('categorie', "categorie")->setRequired(true),
            // YanFied::new("url", "video"),
            Field::new('videoFile', "video")->setFormType(FileType::class)->hideOnIndex(),

            ArrayField::new('commentVideos')->hideOnForm()->hideOnIndex(),
            AssociationField::new('commentVideos')->hideOnDetail()->hideOnIndex()->setRequired(true)->hideOnForm(),

        ];
    }
}
