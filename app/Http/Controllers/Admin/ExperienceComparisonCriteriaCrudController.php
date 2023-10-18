<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Requests\ExperienceComparisonCriteriaRequest;
use App\Models\PositionRequirement;
use App\Models\PositionValue;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/**
 * Class ExperienceComparisonCriteriaCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ExperienceComparisonCriteriaCrudController extends CrudController
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
        CRUD::setModel(\App\Models\ExperienceComparisonCriteria::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/experience-comparison-criteria');
        CRUD::setEntityNameStrings('experience comparison criteria', 'experience comparison criterias');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('positionValue.name')->label('Position Value');
        CRUD::column('min_year');
        CRUD::column('max_year');
        CRUD::column('value');

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
        CRUD::setValidation(ExperienceComparisonCriteriaRequest::class);
        $experienceCriteria = PositionRequirement::findOrCreate(Constants::EXPERIENCE_CRITERIA);
        $values = DB::table('position_values as pv')->join('position_requirements as pr', 'pv.position_requirement_id', '=', 'pr.id')->join('position_types as pt', 'pv.position_type_id', '=', 'pt.id')->where('name', '=', $experienceCriteria->name)->select(['pv.id', 'pt.title'])->get();
        $positionValues = [];
        foreach ($values as $value) {
            $positionValues[$value->id] = $value->title;
        }
        CRUD::field('position_value_id')->type('select_from_array')->options($positionValues)->size(6);
        CRUD::field('min_year')->label('Minimum year')->size(6);
        CRUD::field('max_year')->label('Maximum year')->size(6);
        CRUD::field('value')->size(6);

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
