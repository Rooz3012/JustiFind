<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\PaymentController;

Route::get('/', [SearchController::class, 'index'])->name('home');
Route::get('/lawyer-profile', [SearchController::class, 'profile'])->name('lawyer.profile');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->name('reset.password');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/appointments', [ClientController::class, 'appointments'])->name('client.appointments');
Route::post('/book', [ClientController::class, 'book'])->name('client.book');
Route::post('/upload-document', [ClientController::class, 'uploadDocument'])->name('client.upload');
Route::post('/submit-review', [ClientController::class, 'submitReview'])->name('client.review');
Route::post('/cancel-booking', [ClientController::class, 'cancelBooking'])->name('client.cancel');
Route::post('/reschedule-booking', [ClientController::class, 'rescheduleBooking'])->name('client.reschedule');
Route::get('/recommendations', [RecommendationController::class, 'index'])->name('client.recommendations');
Route::get('/support-tickets', [SupportTicketController::class, 'index'])->name('client.tickets');
Route::post('/support-tickets', [SupportTicketController::class, 'store'])->name('client.tickets.store');
Route::post('/support-tickets/reply', [SupportTicketController::class, 'reply'])->name('client.tickets.reply');

Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
Route::get('/messages/{consultationId}', [MessageController::class, 'conversation'])->name('messages.conversation');
Route::get('/chat/{consultationId}', [MessageController::class, 'getMessages'])->name('chat.messages');

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/mark-read', [NotificationController::class, 'markRead'])->name('notifications.read');

Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

Route::get('/lawyer-dashboard', [LawyerController::class, 'dashboard'])->name('lawyer.dashboard');
Route::get('/lawyer-profile-edit', [LawyerController::class, 'editProfile'])->name('lawyer.profile.edit');
Route::post('/lawyer-profile-update', [LawyerController::class, 'updateProfile'])->name('lawyer.profile.update');
Route::get('/lawyer-availability', [AvailabilityController::class, 'index'])->name('lawyer.availability');
Route::post('/lawyer-availability', [AvailabilityController::class, 'store'])->name('lawyer.availability.store');
Route::post('/lawyer-availability/delete', [AvailabilityController::class, 'delete'])->name('lawyer.availability.delete');
Route::get('/lawyer-analytics', [AnalyticsController::class, 'index'])->name('lawyer.analytics');
Route::post('/update-consultation-status', [LawyerController::class, 'updateStatus'])->name('lawyer.update.status');

Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/delete-booking', [AdminController::class, 'deleteBooking'])->name('admin.delete');
Route::post('/admin/verify-lawyer', [AdminController::class, 'verifyLawyer'])->name('admin.verify');
Route::post('/admin/update-ticket', [AdminController::class, 'updateTicket'])->name('admin.ticket.update');