<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FieldOfStudyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\EducationalLevel;
use App\Models\FieldOfStudy;
use Prologue\Alerts\Facades\Alert;
/**
 * Class FieldOfStudyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FieldOfStudyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(FieldOfStudy::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/field-of-study');
        CRUD::setEntityNameStrings('field of study', 'field of studies');
        $this->setupPermission();
    }

    public function syncFieldOfStudy()
    {
        $fieldOfStudies = [
            "Biology", "Chemistry", "Physics", "Mathematics", "Engineering", "Computer Science", "Economics", "Business Management", "Psychology", "Sociology", "Anthropology", "History", "Art", "Music", "Literature", "Law", "Political Science", "Linguistics", "Philosophy", "Geography", "Earth Sciences", "Astronomy", "Medicine", "computer science",
            "software engineering", "data science", "computer engineering", "information systems", "artificial intelligence", "web development", "cybersecurity", "game development", "computer graphics", "computer animation", "cloud computing", "Accounting", "Anthropology", "Archaeology", "Architecture", "Art History", "Biochemistry", "Bioinformatics", "Biology", "Business", "Chemistry", "Computer Science", "Criminology", "Economics", "Engineering", "English", "Environmental Science", "Finance", "Geography", "History", "Law", "Management", "Marketing", "Mathematics", "Philosophy", "Physics", "Political Science", "Psychology", "Sociology"
        ];
        foreach ($fieldOfStudies as $fieldOfStudy) {
            FieldOfStudy::firstOrCreate(['name' => ucfirst($fieldOfStudy)], ['name' => ucfirst($fieldOfStudy)]);
        }
        Alert::success('Field of study synced successfully')->flash();
        return redirect()->back();
    }

    public function setupPermission()
    {
        $permission_base = 'field_of_study';
        if (!backpack_user()->can($permission_base . '.icrud')) {
            $explodedRoute = explode('/', $this->crud->getRequest()->getRequestUri());
            if (in_array('show', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.show')) {
                    return abort(401);
                }
            }
            if (in_array('create', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.create')) {
                    return abort(401);
                }
            }
            if (in_array('edit', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.edit')) {
                    return abort(401);
                }
            }
            if (in_array('delete', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.delete')) {
                    return abort(401);
                }
            }
            if ($explodedRoute[count($explodedRoute) - 1] == $this->crud->entity_name && !backpack_user()->can($permission_base . '.index')) {
                return abort(401);
            }
            if (!backpack_user()->can($permission_base . '.create')) {
                $this->crud->denyAccess('create');
            }

            if (!backpack_user()->can($permission_base . '.show')) {
                $this->crud->denyAccess('show');
            }

            if (!backpack_user()->can($permission_base . '.edit')) {
                $this->crud->denyAccess('update');
            }

            if (!backpack_user()->can($permission_base . '.delete')) {
                $this->crud->denyAccess('delete');
            }
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label('Field of study');
        CRUD::column('description');
        $this->crud->addButtonFromModelFunction('top', 'sync', 'syncButton', 'end');



        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(FieldOfStudyRequest::class);
        CRUD::field('name')->size(12)->label('Field of study');
        CRUD::field('description');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
