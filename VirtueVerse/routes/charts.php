<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\StudyTrajectoryChartController;
use Illuminate\Support\Facades\Route;

Route::get('charts/retrieveReadPagesChartData/{studyTrajectoryId}', [StudyTrajectoryChartController::class, 'retrieveReadPagesChartData'])->name('study-trajectory.retrieveReadPagesChartData');
Route::get('charts/retrievePagesPerMonthChartData/{studyTrajectoryId}', [StudyTrajectoryChartController::class, 'retrievePagesPerMonthChartData'])->name('study-trajectory.retrievePagesPerMonthChartData');
Route::get('charts/retrieveInputtedRecordsChartdata/{studyTrajectoryId}', [StudyTrajectoryChartController::class, 'retrieveInputtedRecordsChartdata'])->name('study-trajectory.retrieveInputtedRecordsChartdata');
Route::get('charts/retrieveReadingSpeedChartData/{studyTrajectoryId}', [StudyTrajectoryChartController::class, 'retrieveReadingSpeedChartData'])->name('study-trajectory.retrieveReadingSpeedChartData');