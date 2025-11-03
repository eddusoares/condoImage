@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="dashboard-card-wrap mt-0">
                        <form action="{{route('user.kyc.submit')}}" method="post" enctype="multipart/form-data">
                            @csrf
    
                            <x-custom-form identifier="act" identifierValue="kyc"></x-custom-form>
    
                            <div class="form-group">
                                <button type="submit" class="btn button w-100">@lang('Save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
