<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Requests\EmployeeAddressRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\EmployeeAddress;
use App\Models\EmployeeCertificate;
use App\Models\EmployeeContact;
use App\Models\EmployeeFamily;
use App\Models\EmployeeLanguage;
use App\Models\EmploymentStatus;
use App\Models\EmploymentType;
use App\Models\ExternalExperience;
use App\Models\InternalExperience;
use App\Models\JobTitle;
use App\Models\License;
use App\Models\LicenseType;
use App\Models\MaritalStatus;
use App\Models\TrainingAndStudy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Prologue\Alerts\Facades\Alert;

/**
 * Class EmployeeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; } //IMPORTANT HERE
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');
        $this->crud->setShowView('employee.show');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        // CRUD::column('first_name');
        // CRUD::column('father_name');
        // CRUD::column('grand_father_name');
        CRUD::column('name')->type('closure')->function(function ($entry) {
            return $entry->first_name . ' ' . $entry->father_name . ' ' . $entry->grand_father_name;
        });
        // CRUD::column('first_name')->label('Name');

        // CRUD::column('gender');
        // CRUD::column('date_of_birth');
        // CRUD::column('photo');
        // CRUD::column('birth_city');
        // CRUD::column('passport');
        // CRUD::column('driving_licence');
        // CRUD::column('blood_group');
        // CRUD::column('eye_color');
        // CRUD::column('phone_number');
        // CRUD::column('alternate_email');
        // CRUD::column('rfid');
        CRUD::column('employment_identity')->label('Employee ID Number');
        // CRUD::column('marital_status_id');
        // CRUD::column('ethnicity_id');
        // CRUD::column('religion_id');
        // CRUD::column('unit_id');
        CRUD::column('employement_date')->type('date');
        // CRUD::column('salary_step');
        CRUD::column('job_title_id')->type('select')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(4);
        // CRUD::column('employment_type_id');
        // CRUD::column('pention_number');
        // CRUD::column('employment_status_id');
        // CRUD::column('static_salary');
        // CRUD::column('uas_user_id');

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
        CRUD::setValidation(EmployeeRequest::class);
        $this->crud->setCreateContentClass('col-md-12');
        CRUD::field('photo')->size(4)->type('image')->aspect_ratio(1)->crop(true)->upload(true);
        CRUD::field('first_name')->size(4);
        CRUD::field('father_name')->size(4);
        CRUD::field('grand_father_name')->size(4);
        CRUD::field('gender')->type('enum')->size(4);
        CRUD::field('date_of_birth')->size(4);
        CRUD::field('birth_city')->size(4);
        // CRUD::field('passport')->size(4);
        CRUD::field('driving_licence')->size(4)->type('upload')->upload(true);
        CRUD::field('blood_group')->type('enum')->size(4);
        CRUD::field('eye_color')->type('enum')->size(4);
        CRUD::field('phone_number')->size(4);
        CRUD::field('alternate_email')->type('email')->size(4);
        // CRUD::field('rfid')->size(4);
        CRUD::field('employment_identity')->label('Employee ID Number')->size(4);
        CRUD::field('marital_status_id')->type('select')->entity('maritalStatus')->model(MaritalStatus::class)->attribute('name')->size(4);
        CRUD::field('ethnicity_id')->size(4);
        CRUD::field('religion_id')->size(4);
        CRUD::field('unit_id')->size(4);
        CRUD::field('employement_date')->size(4);
        CRUD::field('salary_step')->type('enum')->size(4);
        CRUD::field('job_title_id')->type('select')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(4);
        CRUD::field('employment_type_id')->type('select')->entity('employmentType')->model(EmploymentType::class)->attribute('name')->size(4);
        // CRUD::field('pention_number')->size(4);
        CRUD::field('employment_status_id')->type('select')->entity('employmentStatus')->model(EmploymentStatus::class)->attribute('name')->size(4);
        CRUD::field('static_salary')->type('number')->size(4);
        // CRUD::field('uas_user_id')->size(4);

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
        // dd($this->crud->getCurrentEntry());
        $tabName = 'Personal Information';
        // $this->setupCreateOperation();
        $this->crud->setUpdateContentClass('col-md-12');
        CRUD::setValidation(EmployeeRequest::class);
        CRUD::field('photo')->size(4)->tab($tabName)->type('image')->aspect_ratio(1)->crop(true)->upload(true);
        $this->crud->setCreateContentClass('col-md-12');
        CRUD::field('first_name')->tab($tabName)->size(3);
        CRUD::field('father_name')->tab($tabName)->size(3);
        CRUD::field('grand_father_name')->tab($tabName)->size(3);
        CRUD::field('gender')->type('enum')->tab($tabName)->size(3);
        CRUD::field('date_of_birth')->tab($tabName)->size(3);
        CRUD::field('birth_city')->tab($tabName)->size(3);
        CRUD::field('employment_identity')->tab($tabName)->label('Employee ID Number')->size(3);
        CRUD::field('marital_status_id')->tab($tabName)->type('select')->entity('maritalStatus')->model(MaritalStatus::class)->attribute('name')->tab($tabName)->size(3);
        CRUD::field('phone_number')->tab($tabName)->size(3);
        CRUD::field('ethnicity_id')->tab($tabName)->size(3);
        CRUD::field('eye_color')->tab($tabName)->type('enum')->size(3);
        CRUD::field('religion_id')->tab($tabName)->size(3);
        CRUD::field('blood_group')->tab($tabName)->type('enum')->size(3);
        CRUD::field('alternate_email')->tab($tabName)->type('email')->size(3);
        CRUD::field('driving_licence')->tab($tabName)->size(12)->type('upload')->prefix('storage/')->upload(true);

        $tabName = 'Employee Job';
        CRUD::field('job_title_id')->tab($tabName)->type('select')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(3);
        CRUD::field('unit_id')->tab($tabName)->size(3);
        CRUD::field('employement_date')->tab($tabName)->size(3);
        CRUD::field('employment_type_id')->tab($tabName)->type('select')->entity('employmentType')->model(EmploymentType::class)->attribute('name')->size(3);
        CRUD::field('static_salary')->tab($tabName)->size(3);
        CRUD::field('salary_step')->tab($tabName)->type('enum')->size(3);
        CRUD::field('pention_number')->tab($tabName)->size(3);
        CRUD::field('employment_status_id')->tab($tabName)->type('select')->entity('employmentStatus')->model(EmploymentStatus::class)->attribute('name')->tab($tabName)->size(3);
        $tabName = 'Employee Address';


        // CRUD::field('employeeAddresses')
        // ->type('repeatable')
        // ->label('Employee Address')
        // ->fields([
        //     [
        //         'name'    => 'id',
        //         'type'    => 'hidden',
        //     ],
        //     [
        //         'name'    => 'address_type',
        //         'type'    => 'select_from_array',
        //         'options'     => ['Home' => 'Home', 'Work' => 'Work','Other'=>'Other'],
        //     ],
        //     [
        //         'name'    => 'name',
        //         'type'    => 'text',
        //     ],
        // ])->tab($tabName);
        // $tabName = 'Employee Licenses';
        // CRUD::field('employeeAddresses')
        // ->type('repeatable')
        // ->label('Employee Licenses')
        // ->fields([
        //     [
        //         'name'    => 'id',
        //         'type'    => 'hidden',
        //     ],
        //     [
        //         'name'    => 'license_type_id',
        //         'type'    => 'select_from_array',
        //         'options'=> LicenseType::get()->pluck('name','id')->toArray()
        //     ],
        //     [
        //         'name'    => 'upload_file_id',
        //         'type'    => 'upload',
        //     ],
        // ])->tab($tabName);
        // dd($this->crud->getCurrentEntry());
        // $this->crud->addColumn([ 'name' => 'externalExperiences.company_name','tab'=>$tabName]);
        // CRUD::field('passport')->tab($tabName)->size(3);
        // CRUD::field('rfid')->tab($tabName)->size(3);
        // CRUD::field('uas_user_id')->tab($tabName)->size(3);
    }


    public function update()
    {
        $items = collect(json_decode(request('employeeAddresses'), true));
        // $employeeAddressRequest = new EmployeeAddressRequest();
        // $employeeAddressRules = $employeeAddressRequest->rules();
        $response = $this->traitUpdate();

        $employee_id = $this->crud->entry->id;
        $created_ids = [];

        $items->each(function($item, $key) use ($employee_id, &$created_ids) {
            $item['employee_id'] = $employee_id;
            if ($item['id']) {
                $comment = EmployeeAddress::find($item['id']);
                $comment->update($item);
            } else {
               $created_ids[] = EmployeeAddress::create($item)->id;
            }
        });

        // delete removed Comments
        $related_items_in_request = collect(array_merge($items->where('id', '!=', '')->pluck('id')->toArray(), $created_ids));
        $related_items_in_db = $this->crud->entry->addresses;

        $related_items_in_db?->each(function($item, $key) use ($related_items_in_request) {
            if (!$related_items_in_request->contains($item['id'])) {
                $item->delete();
            }
        });

        return $response;
    }

    protected function setupShowOperation()
    {
        $licenses = License::paginate(10);
        $this->data['employeeLicenses'] = $licenses;
        $employeeAddresses = EmployeeAddress::where('employee_id',$this->crud->getCurrentEntryId())->paginate(10);
        $this->data['employeeAddresses'] = $employeeAddresses;
        $employeeCertificates = EmployeeCertificate::paginate(10);
        $this->data['employeeCertificates'] = $employeeCertificates;
        $employeeContacts = EmployeeContact::paginate(10);
        $this->data['employeeContacts'] = $employeeContacts;
        $employeeLanguages = EmployeeLanguage::paginate(10);
        $this->data['employeeLanguages'] = $employeeLanguages;
        $employeeFamilies = EmployeeFamily::paginate(10);
        $this->data['employeeFamilies'] = $employeeFamilies;
        $internalExperiences = InternalExperience::paginate(10);
        $this->data['internalExperiences'] = $internalExperiences;
        $externalExperiences = ExternalExperience::paginate(10);
        $this->data['externalExperiences'] = $externalExperiences;
        $trainingAndStudies = TrainingAndStudy::paginate(10);
        $this->data['trainingAndStudies'] = $trainingAndStudies;
        // Note: if you HAVEN'T set show.setFromDb to false, the removeColumn() calls won't work
        // because setFromDb() is called AFTER setupShowOperation(); we know this is not intuitive at all
        // and we plan to change behaviour in the next version; see this Github issue for more details
        // https://github.com/Laravel-Backpack/CRUD/issues/3108
    }


}
