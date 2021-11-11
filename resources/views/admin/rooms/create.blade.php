@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.room.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.rooms.store") }}" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="form-group">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addImage">Add Image</button>
                <div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-group">
                                    <img id="img" width="100%" class="img-thumbnail" style="border: none; background-color: transparent" src="{{ asset('images/image-icon.png') }}" />
                                    <label class="btn btn-primary btn-block">
                                        Browse&hellip;<input value="" type="file" name="image" style="display: none;" id="upload" accept="image/*" />
                                    </label>
                                </div>
                                <hr>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label class="required" for="name">{{ trans('cruds.room.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.room.fields.name_helper') }}</span>
                </div>
                <div class="col-md-6">
                    <label class="required" for="room_type_id">{{ trans('cruds.room.fields.room_type') }}</label>
                    <select class="form-control select2 {{ $errors->has('room_type') ? 'is-invalid' : '' }}" name="room_type_id" id="room_type_id" required>
                        @foreach($room_types as $id => $room_type)
                            <option value="{{ $id }}" {{ old('room_type_id') == $id ? 'selected' : '' }}>{{ $room_type }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('room_type_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('room_type_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.room.fields.room_type_helper') }}</span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label class="required">Capacity</label>
                    <input class="form-control {{ $errors->has('capacity') ? 'is-invalid' : '' }}" type="number" name="capacity" value="{{ old('capacity', '') }}">
                    @if($errors->has('capacity'))
                        <div class="invalid-feedback">
                            {{ $errors->first('capacity') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="required">Amount</label>
                    <input type="number" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" name="amount" value="{{ old('amount', '') }}">
                    @if($errors->has('amount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('amount') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="featured" name="featured" value="1" @if(old('featured')) checked @endif>
                        <label class="form-check-label" for="featured">Featured</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Description</label>
                    <textarea class="form-control" name="description" cols="30" rows="10">{{ old('name', '') }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection