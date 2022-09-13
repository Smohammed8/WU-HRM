<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UploadFileRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Constants;
use App\Models\UploadFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class UploadFileCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UploadFileCrudController extends CrudController
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
        CRUD::setModel(\App\Models\UploadFile::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/upload-file');
        CRUD::setEntityNameStrings('upload file', 'upload files');
    }

    public static function fileUpload($file, $path = 'misc')
    {
        $fileModel = new UploadFile();
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs($path, $fileName, 'public');
        $fileModel->name = time() . '_' . $file->getClientOriginalName();
        $fileModel->path = '/storage/' . $filePath;
        $fileModel->save();
        return $fileModel;
    }

    // public static function deleteFile(File $file)
    // {
    //     $filePath = public_path($file->file_path);
    //     if (FacadesFile::exists($filePath)) {
    //         unlink($filePath);
    //         return 200;
    //     }
    //     return 404;
    // }

    public static function uploadBase64($image_64,$path='misc')
    {
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
        // find substring fro replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        $imageName = time() . '.' . $extension;
        $fileModel = new UploadFile;
        $fileModel->name = $imageName;
        $fileModel->path = $path;
        $fileModel->save();
        Storage::disk('local')->put($path.$imageName, base64_decode($image));
        return $fileModel;
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('path');

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
        CRUD::setValidation(UploadFileRequest::class);

        CRUD::field('name');
        CRUD::field('path');

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
