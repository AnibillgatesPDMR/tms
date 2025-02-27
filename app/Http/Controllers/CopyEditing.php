<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class CopyEditing extends Model
{
    public static function getJobs()
    {

        $book = DB::table('book')
            ->join('users', 'users.id', '=', 'book.created_by')
            ->join('client_type', 'client_type.id', '=', 'book.type')
            ->join('client', 'client.id', '=', 'book.client_id')
            ->join('journal', 'journal.id', '=', 'book.journal_id')
            ->select('book.id', 'book.book_name', 'book.created_at', 'users.name', 'client_type.type', 'client.client_name', 'journal.journal_name')
            ->orderBy('book.created_at', 'desc')
            ->where('book.assign_to', '=', '2')
            ->paginate(10);
        return $book;
    }

    public static function getAllChapter($bookid)
    {
        $chapter = DB::table('chapter')
            ->join('users', 'users.id', '=', 'chapter.created_by')
            ->join('client_type', 'client_type.id', '=', 'chapter.type')
            ->join('book', 'book.id', '=', 'chapter.book_id')
            ->select('chapter.id', 'chapter.chapter_name', 'chapter.created_at', 'users.name', 'client_type.type', 'book.book_name', 'chapter.is_assigned')
            ->where('chapter.book_id', '=', $bookid)
            ->paginate(10);
        return $chapter;
    }

    public static function getCopyEditingUsers()
    {
        $ceuser = DB::table('users')
            ->join('user_team', 'users.id', '=', 'user_team.user_id')
            ->select('users.name', 'users.id')
            ->where('user_team.team_id', '=', '1')
            ->get();
        return $ceuser;
    }

    public static function assignUser($assignto, $chapterid, $createdBy, $duedate, $job_type, $queries)
    {

        $now = date("Y-m-d h:i:s");
        $id = DB::table('users_job')->insertGetId(['user_id' => $assignto, 'chapter_id' => $chapterid, 'created_by' => $createdBy, 'created_at' => $now, 'due_date' => $duedate, 'job_type' => $job_type, 'queries' => $queries]);

        $chapter = DB::table('chapter')
            ->where('id', $chapterid)
            ->update(['is_assigned' => '1']);

        return $id;
    }

    public static function getMyJobs($userid)
    {
        $ceuser = DB::table('users_job')
            ->join('chapter', 'users_job.chapter_id', '=', 'chapter.id')
            ->join('client', 'client.id', '=', 'chapter.client_id')
            ->join('journal', 'journal.id', '=', 'chapter.journal_id')
            ->join('client_type', 'client_type.id', '=', 'chapter.type')
            ->join('book', 'book.id', '=', 'chapter.book_id')
            ->join('users', 'users.id', '=', 'users_job.created_by')
            ->join('job_type', 'job_type.id', '=', 'users_job.job_type')
            ->select('chapter.chapter_name', 'chapter.id', 'client.client_name', 'journal.journal_name', 'book.book_name', 'client_type.type', 'chapter.created_at', 'users.name', 'users_job.due_date', 'users_job.queries', 'job_type.job_type', 'job_type.color_code')
            ->where('users_job.user_id', '=', $userid)
            ->paginate(10);
            


        return $ceuser;
    }

    public static function getAllChapterStage($chapterId)
    {
        $stage = DB::table('chapter_upload')
            ->join('article_stage', 'article_stage.id', '=', 'chapter_upload.article_stage')
            ->join('article_sub_stage', 'article_sub_stage.id', '=', 'chapter_upload.article_sub_stage')
            ->select('*')
            ->where('chapter_upload.chapter_id', '=', $chapterId)
            ->paginate(10);
        return $stage;
    }

    public static function getAllChapterStageFiles($chapterId, $stageid)
    {
        $stage = DB::table('chapter_upload')
            ->join('article_stage', 'article_stage.id', '=', 'chapter_upload.article_stage')
            ->join('article_sub_stage', 'article_sub_stage.id', '=', 'chapter_upload.article_sub_stage')
            ->select('chapter_upload.file_name', 'chapter_upload.file_path', 'chapter_upload.created_at')
            ->where('chapter_upload.chapter_id', '=', $chapterId)
            ->where('chapter_upload.article_sub_stage', '=', $stageid)
            ->paginate(10);
        return $stage;
    }

    /* Author : Muhammed Gani
    the below function used for get job type list from 'job_type" table

     */

    public static function getJobtype()
    {
        $jobtype = DB::table('job_type')
            ->select('*')
            ->where('job_type.job_status', '=', 'Active')
            ->get();
        return $jobtype;
    }

    public static function getAllWorkType()
    {
        $worktype = DB::table('work_type')
            ->select('*')
            ->where('work_type.work_status', '=', 'Active')
            ->get();
        return $worktype;

    }

    /* Code End */

}
