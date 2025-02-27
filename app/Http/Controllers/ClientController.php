<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\User;
use App\Role;
use App\Permission;
use App\Authorizable;
use App\Mail\AppMailler;
use Mail;
use File;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $result = Client::getClient();

        return view('client.index', compact('result'));
    }

    public function store(Request $request)
    {
        $this->validate($request, ['type' => 'required|min:1', 'name' => 'required|unique:roles']);
        $type = $request->get('type');
        $filepath = Client::getFilePath($type);
        if ($type == '1') {
            $type = 'Book';
        } else {
            $type = 'Journal';
        }
        $typePath = $filepath->file_path.$type;
        $path = $typePath.'/'.$request->get('name');
        
        if(!File::exists($typePath)) {
            File::makeDirectory($typePath, $mode = 0777, true, true);
        }
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $stages = Client::getStage();
        foreach ($stages as $stage) {
            mkdir($path.'/'.$stage->stage, 0777, true);
        }

        $createdBy = Auth::user()->id;
        $zerothStage = $path.'/'.'01_Author_Download_Files';
    	Client::createClient($request->get('type'), $request->get('name'), $zerothStage, $createdBy);
    	flash('Client Added');

        return redirect()->back();
    }

    public function show()
    {
    	$result = Client::getJournal();
    	$clients = Client::getAllClient();
        $types = Client::getType();

        return view('client.journal', compact('result', 'clients', 'types'));	
    }

    public function dashBoard()
    {
    	$client = Client::getClient();
    	$journal = Client::getJournal();
    	return view('client.dashboard', compact('client', 'journal'));
    }

    public function createJournal(Request $request)
    {
    	$this->validate($request, ['type' => 'required|min:1', 'name' => 'required|unique:roles', 'client' => 'required|min:1']);
    	$client = Client::getClientById($request->get('client'));
    	$path = $client->file_path.'/'.$request->get('name');
    	
    	if (File::makeDirectory($path, $mode = 0777, true, true)) {
            $createdBy = Auth::user()->id;
        	Client::createJournal($request->get('type'), $request->get('client'), $request->get('name'), $path, $createdBy);
        	flash('Journal Added');
        }

        return redirect()->back();
    }

    public function getJournal($id)
    {
    	$journal = Client::getJournalById($id);
    	$clients = Client::getAllClient();

        return view('client.edit', compact('journal', 'clients'));
    }

    public function updateJournal(Request $request)
    {
    	$this->validate($request, ['name' => 'required|unique:roles', 'client' => 'required|min:1', 'journalId' => 'required|min:1']);
    	$client = Client::getClientById($request->get('client'));
    	$path = $client->file_path.'/'.$request->get('name');
    	
    	if (File::makeDirectory($path, $mode = 0777, true, true)) {
        	Client::updateJournal($request->get('client'), $request->get('name'), $path, $request->get('journalId'));
        	flash('Journal Updated');
        }

        return redirect('clients/journal');
    }

    public function deleteJournal($id)
    {
    	if (Client::deleteJournal($id)) {
    		flash('Journal Deleted');
    	} else {
    		flash('Journal cant be deleted');
    	}
    	return redirect()->back();
    }

    public function clientByType(Request $request) {
        $client = Client::getClientByType($request->get('type_id'));
        return $client;
    }

    public function checkClientName(Request $request) {
        $client = Client::getClientByName($request->get('name'), $request->get('type'));
        if (!$client->isEmpty()) {
            return 'exist';
        } else {
            return 'not_exist';
        }
    }

    public function checkJournalName(Request $request) {
        $journal = Client::getJournalByName($request->get('name'), $request->get('type'), $request->get('client'));
        if (!$journal->isEmpty()) {
            return 'exist';
        } else {
            return 'not_exist';
        }
    }

    public function checkBookName(Request $request) {
        $book = Client::getBookByName($request->get('name'), $request->get('type'), $request->get('client'), $request->get('journal'));
        if (!$book->isEmpty()) {
            return 'exist';
        } else {
            return 'not_exist';
        }    
    }
}
