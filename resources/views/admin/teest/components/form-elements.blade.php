<div class="form-group row align-items-center" :class="{'has-danger': errors.has('uuid'), 'has-success': fields.uuid && fields.uuid.valid }">
    <label for="uuid" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.teest.columns.uuid') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.uuid" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('uuid'), 'form-control-success': fields.uuid && fields.uuid.valid}" id="uuid" name="uuid" placeholder="{{ trans('admin.teest.columns.uuid') }}">
        <div v-if="errors.has('uuid')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('uuid') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('connection'), 'has-success': fields.connection && fields.connection.valid }">
    <label for="connection" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.teest.columns.connection') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.connection" v-validate="'required'" id="connection" name="connection"></textarea>
        </div>
        <div v-if="errors.has('connection')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('connection') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('queue'), 'has-success': fields.queue && fields.queue.valid }">
    <label for="queue" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.teest.columns.queue') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.queue" v-validate="'required'" id="queue" name="queue"></textarea>
        </div>
        <div v-if="errors.has('queue')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('queue') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('payload'), 'has-success': fields.payload && fields.payload.valid }">
    <label for="payload" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.teest.columns.payload') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.payload" v-validate="'required'" id="payload" name="payload"></textarea>
        </div>
        <div v-if="errors.has('payload')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('payload') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('exception'), 'has-success': fields.exception && fields.exception.valid }">
    <label for="exception" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.teest.columns.exception') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.exception" v-validate="'required'" id="exception" name="exception"></textarea>
        </div>
        <div v-if="errors.has('exception')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('exception') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('failed_at'), 'has-success': fields.failed_at && fields.failed_at.valid }">
    <label for="failed_at" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.teest.columns.failed_at') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.failed_at" :config="datetimePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('failed_at'), 'form-control-success': fields.failed_at && fields.failed_at.valid}" id="failed_at" name="failed_at" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_date_and_time') }}"></datetime>
        </div>
        <div v-if="errors.has('failed_at')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('failed_at') }}</div>
    </div>
</div>


