<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Client;
use App\LoginTeam;
use App\CopyEditing;
use App\Permission;
use App\Authorizable;
use App\Mail\AppMailler;
use Mail;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoveController extends Controller
{
    public function dashBoard() {
    	$client = Client::getAllClientCount();
        $chapter = LoginTeam::getChapterCount();
        $book = Client::getAllBookCount();
		$journal = Client::getJournal();
		$jobs = CopyEditing::getJobs();
		$userid = Auth::user()->id;
    	$myjobs = CopyEditing::getMyJobs($userid);

    	return view('copyediting.dashboard', compact('book', 'chapter', 'client','jobs','myjobs'));
    }

    public function bookAssign(Request $request) {
    	$this->validate($request, [
            'assignto' => 'required|min:1',
            'bookid' => 'required|min:1'
        ]);

        $assignto = $request->get('assignto');
        $bookid = $request->get('bookid');

        $bookData = LoginTeam::getBookById($bookid);
        $assign = LoginTeam::getTeamStageByid($assignto);

        $src = $bookData->file_path;
        $clientPath = $bookData->client_filepath;
        $clientPath = explode("/", $clientPath);
        array_pop($clientPath);
        $fileurl = implode("/", $clientPath);
        
		$dst = $fileurl.'/'.$assign->stage.'/'.$bookData->journal_name;

		if(!File::exists($dst)) {
            File::makeDirectory($dst, $mode = 0777, true, true);
        }

		$dst = $dst.'/'.$bookData->book_name;
		if(!File::exists($dst)) {
            File::makeDirectory($dst, $mode = 0777, true, true);
        }

		$this->recurse_copy($src, $dst);

		LoginTeam::updateAssignStatus($assignto, $bookid);

		flash('File moved to '.$assign->stage);

		return redirect()->back();
    }

    public function recurse_copy($src,$dst) {
		$dir = opendir($src); 
		@mkdir($dst); 
		while(false !== ( $file = readdir($dir)) ) {
		    if (( $file != '.' ) && ( $file != '..' )) {
		        if ( is_dir($src . '/' . $file) ) { 
		            $this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
		        }
		        else {
		            copy($src . '/' . $file,$dst . '/' . $file); 
		        } 
		    } 
		} 
		closedir($dir); 
	}
}
