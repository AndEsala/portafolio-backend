<?php

use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;
use Illuminate\Support\Facades\Route;

// Rutas públicas para consumir desde Next.js / React
Route::get('/profile', [ProfileController::class, 'index']);
Route::post('/skills', [SkillController::class, 'index']);

// Proyectos (Lista completa y detalle)
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project:slug}', [ProjectController::class, 'show']);

Route::get('/experiences', [ExperienceController::class, 'index']);

// Ruta para recibir mensajes del formulario de contacto
Route::post('/messages', [MessageController::class, 'store']);
