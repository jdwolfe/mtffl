<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

// Home
Route::get('/', 'HomeController@index')->name('home');
Route::get('/hall-of-champions', 'HomeController@hallofChampions')->name('hall-of-champions');
Route::get('/division-winners', 'HomeController@divisionWinners')->name('division-winners');
Route::get('/history-grid/{status?}', 'HomeController@historyGrid')->name('history-grid');
Route::get('/trophies', 'HomeController@trophies')->name('trophies');
Route::get('/rulebook', 'HomeController@rulebook')->name('rulebook');
Route::get('/rule-amendments', 'HomeController@ruleAmendments')->name('rule-amendments');
Route::get('/scoring-rules', 'HomeController@scoringRules')->name('scoring-rules');
Route::get('/cost', 'HomeController@cost')->name('cost');
Route::get('/tie-breakers', 'HomeController@tieBreakers')->name('tie-breakers');
Route::get('/point-calculator', 'HomeController@pointCalculator')->name('point-calculator');
Route::get('/draft-day', 'HomeController@draftDay')->name('draft-day');

// Team
Route::get('/teams/{option?}', 'TeamController@index')->name('teams');
Route::get('/team/info/{team_id}', 'TeamController@info')->name('teamInfo');
Route::get('/team/schedule/{team_id}/{season}', 'TeamController@schedule')->name('teamSchedule');
Route::get('/team/matchup/{team_id}/{opp_id}', 'TeamController@matchup')->name('teamMatchup');

// Admin
Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/admin/showHome/{option}', 'AdminController@showHome')->name('showHome');
Route::post('/admin/newSeason', 'AdminController@newSeason')->name('newSeason');
