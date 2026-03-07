<?php

use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\IndustryController as AdminIndustryController;
use App\Http\Controllers\Admin\ProposalController as AdminProposalController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Agency\CampaignController as AgencyCampaignController;
use App\Http\Controllers\Agency\ProfileController as AgencyProfileController;
use App\Http\Controllers\Agency\ProjectController as AgencyProjectController;
use App\Http\Controllers\Agency\ProposalController as AgencyProposalController;
use App\Http\Controllers\Company\CampaignController as CompanyCampaignController;
use App\Http\Controllers\Company\ProfileController as CompanyProfileController;
use App\Http\Controllers\Company\ProposalController as CompanyProposalController;
use App\Http\Controllers\Company\ReviewController as CompanyReviewController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/how-it-works', [PublicController::class, 'howItWorks'])->name('how-it-works');
Route::get('/features', [PublicController::class, 'features'])->name('features');
Route::get('/pricing', [PublicController::class, 'pricing'])->name('pricing');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');
Route::get('/agencies', [PublicController::class, 'agencies'])->name('agencies.index');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'submitContact'])->name('contact.submit');

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard.redirect');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::post('/conversations/{conversation}/messages', [ConversationController::class, 'store'])->name('conversations.messages.store');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    Route::post('/reports', [PublicController::class, 'storeReport'])->name('reports.store');
});

Route::middleware(['auth', 'verified', 'role:company'])->prefix('company')->name('company.')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'company'])->name('dashboard');

    Route::get('/profile', [CompanyProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [CompanyProfileController::class, 'update'])->name('profile.update');

    Route::resource('campaigns', CompanyCampaignController::class);
    Route::put('campaigns/{campaign}/status', [CompanyCampaignController::class, 'updateStatus'])->name('campaigns.status');
    Route::get('campaigns/{campaign}/proposals', [CompanyProposalController::class, 'index'])->name('campaigns.proposals');
    Route::post('proposals/{proposal}/shortlist', [CompanyProposalController::class, 'shortlist'])->name('proposals.shortlist');
    Route::post('proposals/{proposal}/accept', [CompanyProposalController::class, 'accept'])->name('proposals.accept');
    Route::post('proposals/{proposal}/reject', [CompanyProposalController::class, 'reject'])->name('proposals.reject');

    Route::get('reviews', [CompanyReviewController::class, 'index'])->name('reviews.index');
    Route::post('campaigns/{campaign}/reviews', [CompanyReviewController::class, 'store'])->name('reviews.store');
});

Route::middleware(['auth', 'verified', 'role:agency'])->prefix('agency')->name('agency.')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'agency'])->name('dashboard');

    Route::get('/profile', [AgencyProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AgencyProfileController::class, 'update'])->name('profile.update');

    Route::get('/campaigns', [AgencyCampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/{campaign}', [AgencyCampaignController::class, 'show'])->name('campaigns.show');
    Route::get('/favorites', [AgencyCampaignController::class, 'favorites'])->name('favorites.index');
    Route::post('/campaigns/{campaign}/favorite', [AgencyCampaignController::class, 'favorite'])->name('campaigns.favorite');
    Route::delete('/campaigns/{campaign}/favorite', [AgencyCampaignController::class, 'unfavorite'])->name('campaigns.unfavorite');

    Route::get('/campaigns/{campaign}/proposals/create', [AgencyProposalController::class, 'create'])->name('proposals.create');
    Route::post('/campaigns/{campaign}/proposals', [AgencyProposalController::class, 'store'])->name('proposals.store');
    Route::get('/proposals', [AgencyProposalController::class, 'index'])->name('proposals.index');
    Route::get('/proposals/{proposal}', [AgencyProposalController::class, 'show'])->name('proposals.show');
    Route::get('/proposals/{proposal}/edit', [AgencyProposalController::class, 'edit'])->name('proposals.edit');
    Route::put('/proposals/{proposal}', [AgencyProposalController::class, 'update'])->name('proposals.update');
    Route::delete('/proposals/{proposal}', [AgencyProposalController::class, 'destroy'])->name('proposals.destroy');

    Route::get('/projects', [AgencyProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{proposal}', [AgencyProjectController::class, 'show'])->name('projects.show');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');

    Route::get('/campaigns', [AdminCampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/{campaign}', [AdminCampaignController::class, 'show'])->name('campaigns.show');
    Route::put('/campaigns/{campaign}/status', [AdminCampaignController::class, 'updateStatus'])->name('campaigns.status');

    Route::get('/proposals', [AdminProposalController::class, 'index'])->name('proposals.index');
    Route::get('/proposals/{proposal}', [AdminProposalController::class, 'show'])->name('proposals.show');
    Route::put('/proposals/{proposal}/status', [AdminProposalController::class, 'updateStatus'])->name('proposals.status');

    Route::resource('categories', AdminCategoryController::class);
    Route::resource('services', AdminServiceController::class);
    Route::resource('industries', AdminIndustryController::class);

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::put('/reports/{report}/status', [AdminReportController::class, 'updateStatus'])->name('reports.status');

    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
