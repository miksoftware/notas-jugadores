@extends('errors::minimal')

@section('title', 'Acceso denegado')
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'No tienes permiso para acceder a esta sección.'))
