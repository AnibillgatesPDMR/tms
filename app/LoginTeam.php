<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class LoginTeam extends Model
{
    public static function createBook($bookArray) {
        $id = DB::table('book')->insertGetId($bookArray);
        return $id;
    }

    public static function getBookById($bookid) {
        $book = DB::table('book')
            ->join('client', 'book.client_id', '=', 'client.id')
            ->join('journal', 'book.journal_id', '=', 'journal.id')
            ->select('book.id', 'book.client_id', 'book.book_name', 'client.client_name', 'book.created_at', 'book.file_path', 'journal.journal_name', 'client.file_path as client_filepath')
            ->where('book.id', '=', $bookid)
            ->first();
        return $book;
    }

    public static function createChapter($chapterArray)
    {
    	$id = DB::table('chapter')->insertGetId($chapterArray);
        return $id;
    }

    public static function uploadChapter($uploadArray) {
        $id = DB::table('chapter_upload')->insertGetId($uploadArray);
        return $id;
    }

    public static function getChapter() {
    	$chapter = DB::table('chapter')
    		->join('journal', 'journal.id', '=', 'chapter.journal_id')
    		->join('client', 'journal.client_id', '=', 'client.id')
            ->join('book', 'book.id', '=', 'chapter.book_id')
            ->join('users', 'users.id', '=', 'chapter.created_by')
            ->join('client_type', 'client_type.id', '=', 'chapter.type')
            ->select('chapter.id','chapter.chapter_name', 'journal.journal_name', 'client.client_name', 'chapter.created_at', 'users.name', 'client_type.type', 'book.book_name')
            ->orderBy('chapter.created_at', 'desc')
            ->paginate(10);
   		return $chapter;
    }

    public static function getChapterCount() {
        $chapter = DB::table('chapter')->count();
        return $chapter;
    }

    public static function getBookByClientId($typeId, $clientid, $journalId) {
        $chapter = DB::table('book')
            ->select('id','book_name')
            ->where('type', '=', $typeId)
            ->where('client_id', '=', $clientid)
            ->where('journal_id', '=', $journalId)
            ->get();
        return $chapter;
    }

    public static function getChapterByClientId($typeId, $clientid, $journalId, $bookid) {
        $chapter = DB::table('chapter')
            ->select('id','chapter_name')
            ->where('type', '=', $typeId)
            ->where('client_id', '=', $clientid)
            ->where('journal_id', '=', $journalId)
            ->where('book_id', '=', $bookid)
            ->get();
        return $chapter;
    }

    public static function getAllChapter($clientid, $journalId, $bookid) {
        $chapter = DB::table('chapter')
            ->join('users', 'users.id', '=', 'chapter.created_by')
            ->join('client_type', 'client_type.id', '=', 'chapter.type')
            ->join('book', 'book.id', '=', 'chapter.book_id')
            ->select('chapter.id','chapter.chapter_name', 'chapter.created_at', 'users.name', 'client_type.type', 'book.book_name', 'chapter.is_assigned')
            ->where('chapter.client_id', '=', $clientid)
            ->where('chapter.journal_id', '=', $journalId)
            ->where('chapter.book_id', '=', $bookid)
            ->paginate(10);
        return $chapter;
    }

    public static function getChapterById($chapterId) {
        $chapter = DB::table('chapter')
            ->select('id','chapter_name', 'file_path')
            ->where('id', '=', $chapterId)
            ->first();
        return $chapter;    
    }

    public static function getArticleStage() {
        $stage = DB::table('article_stage')->get();
        return $stage;
    }

    public static function getTeamStage() {
        $stage = DB::table('stages')->get();
        return $stage;
    }

    public static function getTeamStageByid($id) {
        $stage = DB::table('stages')->where('id', $id)->first();
        return $stage;
    }

    public static function getChapterSubStage($stageid) {
        $stage = DB::table('article_sub_stage')->where('stage_id','=', $stageid)->get();
        return $stage;
    }

    public static function getSubStageById($subStageid) {
        $stage = DB::table('article_sub_stage')
        ->join('article_stage', 'article_sub_stage.stage_id', '=', 'article_stage.id')
        ->where('article_sub_stage.id','=', $subStageid)->first();
        return $stage;    
    }

    public static function getAllJournalCount($clientid) {
        $client = DB::table('client')
        ->join('journal', 'client.id', '=', 'journal.client_id')
        ->join('chapter', 'journal.id', '=', 'chapter.journal_id')
        ->select('journal.id as id', 'journal.journal_name', DB::raw("count(chapter.journal_id) as count"))
        ->where('client.id', '=', $clientid)
        ->groupBy('client.id')
        ->get();
        return $client;
    }

    public static function getAllChapterStage($clientid, $journalid, $bookid, $chapterId){
        $stage = DB::table('chapter_upload')
        ->join('article_stage', 'article_stage.id', '=', 'chapter_upload.article_stage')
        ->join('article_sub_stage', 'article_sub_stage.id', '=', 'chapter_upload.article_sub_stage')
        ->select('*')
        ->where('chapter_upload.client_id', '=', $clientid)
        ->where('chapter_upload.journal_id', '=', $journalid)
        ->where('chapter_upload.book_id', '=', $bookid)
        ->where('chapter_upload.chapter_id', '=', $chapterId)
        ->paginate(10);
        return $stage;
    }

    public static function getAllChapterStageFiles($clientid, $journalid, $bookid, $chapterId, $stageid){
        $stage = DB::table('chapter_upload')
        ->join('article_stage', 'article_stage.id', '=', 'chapter_upload.article_stage')
        ->join('article_sub_stage', 'article_sub_stage.id', '=', 'chapter_upload.article_sub_stage')
        ->select('chapter_upload.file_name', 'chapter_upload.file_path', 'chapter_upload.created_at')
        ->where('chapter_upload.client_id', '=', $clientid)
        ->where('chapter_upload.journal_id', '=', $journalid)
        ->where('chapter_upload.book_id', '=', $bookid)
        ->where('chapter_upload.chapter_id', '=', $chapterId)
        ->where('chapter_upload.article_sub_stage', '=', $stageid)
        ->paginate(10);
        return $stage;
    }

    public static function getBooks() {
        $book = DB::table('book')
            ->join('users', 'users.id', '=', 'book.created_by')
            ->join('client_type', 'client_type.id', '=', 'book.type')
            ->join('client', 'client.id', '=', 'book.client_id')
            ->join('journal', 'journal.id', '=', 'book.journal_id')
            ->select('book.id','book.book_name', 'book.created_at', 'users.name', 'client_type.type', 'client.client_name', 'journal.journal_name')
            ->orderBy('book.created_at', 'desc')
            ->paginate(10);
        return $book;
    }

    public static function updateAssignStatus($assignto, $bookid) {
        $book = DB::table('book')
            ->where('id', $bookid)
            ->update(['assign_to' => $assignto]);
        return $book;
    }
}
