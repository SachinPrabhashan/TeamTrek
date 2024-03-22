<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\SupportContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\SupportContractInstance;
use Illuminate\Support\Facades\Session;
use App\Models\SubTask;
use App\Models\RemainingHour;
use App\Models\SupportPayment;
use App\Models\ExtraCharger;
use App\Models\ScView;
use Illuminate\Support\Facades\Auth;

class SupportPaymentController extends Controller
{
    public function financialHealthIndex(SupportPayment $supportpayment)
    {
        //$this->authorize('view', $usermanagement);
        $tasks = Task::All();
        $scInstances=SupportContractInstance::All();
        $supportcontracts=SupportContract::All();
        $subtasks=SubTask::All();
        $remainingHours=RemainingHour::All();
        $extraChargers=ExtraCharger::All();

        return view('Support_Contract.ScFinancialHealth', compact('tasks','scInstances','supportcontracts','subtasks','remainingHours','extraChargers'));
    }

    public function getFinancialData(Request $request)
    {
        $supportContractId = $request->input('supportContractId');
        $year = $request->input('year');

        $supportContractInstance = SupportContractInstance::where('support_contract_id', $supportContractId)
            ->where('year', $year)
            ->first();

        if (!$supportContractInstance) {
            // Display SweetAlert if no support contract instance is found
            return response()->json(['error' => 'Support contract instance not found'], 404)
                ->header('Content-Type', 'application/json')
                ->header('X-Message-Type', 'error')
                ->header('X-Message', 'No support contract instance found for the selected values');
        }
        //This fetch only the first task which has the matching support_contract_instance_id
        $task = Task::where('support_contract_instance_id', $supportContractInstance->id)->first();

        /*$ongoingTasks = Task::where('support_contract_instance_id', $supportContractInstance->id)
        ->where('isCompleted', false)
        ->get();

        $completedTasks = Task::where('support_contract_instance_id', $supportContractInstance->id)
            ->where('isCompleted', true)
            ->get();*/

        $supportContract = SupportContract::find($supportContractInstance->support_contract_id);



        $remainingHours = $extraChargers = $taskaccess = null;

        if ($task) {
            $remainingHours = RemainingHour::where('task_id', $task->id)->latest()->first();
            $extraChargers = ExtraCharger::where('task_id', $task->id)->latest()->first();
            $taskaccess = TaskAccess::where('task_id', $task->id)->get();
        }

        // Prepare the data to be returned
        $responseData = [
            'supportContractInstance' => $supportContractInstance,
            'supportContract' => $supportContract,
            'task' => $task,
            'taskAccess' => $taskaccess,
            'remainingHours' => $remainingHours,
            'extraChargers' => $extraChargers,
            //'ongoingTasks' => $ongoingTasks,
            //'completedTasks' => $completedTasks,
        ];
        //\Log::info('Response Data:', $responseData);
        return response()->json($responseData);
    }

}

