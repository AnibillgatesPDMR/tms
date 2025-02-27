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

class FileController extends Controller
{
    public function dashBoard() {
    	$client = Client::getAllClientCount();
        $chapter = LoginTeam::getChapterCount();
        $book = Client::getAllBookCount();
    	$journal = Client::getJournal();

    	return view('filedispatchteam.dashboard', compact('book', 'chapter', 'client'));
    }

    public function jobsList() {
    	$jobs = CopyEditing::getJobs();
    	return view('filedispatchteam.joblist', compact('jobs'));
    }

    public function jobChapter($bookid) {
    	$chapter = CopyEditing::getAllChapter($bookid);
    	$ceusers = CopyEditing::getCopyEditingUsers();
        return view('filedispatchteam.chapterlist', compact('chapter', 'ceusers'));
    }

    public function userAssign(Request $request) {
    	$this->validate($request, [
            'assignto' => 'required|min:1',
            'duedate' => 'required|min:1',
            'chapterid' => 'required|min:1'
        ]);

        $assignto = $request->get('assignto');
        $duedate = $request->get('duedate');
        $chapterid = $request->get('chapterid');
        $createdBy = Auth::user()->id;

        CopyEditing::assignUser($assignto, $chapterid, $createdBy, $duedate);

       	flash('Job Assigned');

		return redirect()->back();
    }

    public function myJobsList() {
    	$userid = Auth::user()->id;
    	$myjobs = CopyEditing::getMyJobs($userid);

    	return view('filedispatchteam.myjoblist', compact('myjobs'));
    }

    public function stageList($chapterid) {
        $articleStage = CopyEditing::getAllChapterStage($chapterid);
        return view('filedispatchteam.stage', compact('articleStage'));    
    }

    public function fileList($chapterid, $stageid) {
        $articleStage = CopyEditing::getAllChapterStageFiles($chapterid, $stageid);
        return view('filedispatchteam.files', compact('articleStage'));
    }
}
