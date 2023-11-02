<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent; // Import the Agent class
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Facades\DB;

class AccessLogController extends Controller
{
    public function index()
{
    $logs = AccessLog::latest()->paginate(15); // Fetch and paginate access logs

     // Add browser name and version to each log entry
    //  $logs->each(function ($log) {
    //     $agent = new Agent();
    //     $agent->setUserAgent($log->user_agent);
    //     $log->browserName = $agent->browser(); // Browser name
    //     $log->browserVersion = $agent->version(); // Browser version
    // });
    
    return view('access_logs.index', compact('logs'));
}

public function truncateTable()
{
    DB::table('access_logs')->truncate();
$rowsAffected = DB::affectingStatement('TRUNCATE TABLE access_logs');
if ($rowsAffected === 0) {
    Alert::success(trans('backpack::crud.update_success'))->flash();
}

    return redirect()->back();
}

public function bulkDelete(Request $request)
{
    $selectedItems = $request->input('selected_items');

    if ($selectedItems) {
        AccessLog::whereIn('id', $selectedItems)->delete();
        Alert::success(trans('backpack::crud.update_success'))->flash();
     
      
    }

    return redirect()->back();
}

public function destroy($id)
{
    AccessLog::destroy($id); // Delete a log entry
    return redirect('/access-logs')->with('success', 'Log entry deleted successfully');
}
}
