<div id="faq-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">{{__('Faqs Add/Edit')}}</h4>
                <button type="button" class="close close_modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{route('faqsSettingSave')}}"  method="POST" id="submit_faqs_id" class="submit_faq" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="question">{{__('Question')}} <span class="text-danger">*</span></label>
                                <input type="text" name="question"  value="" id="question" placeholder="{{__('Add Question')}}" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label>{{__('Answer')}}</label>
                                <textarea name="answer" placeholder="{{__('Answer here')}}" id="answer" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">{{__('Status')}}</label>
                                <select class="form-control status" name="status" required >
                                    <option value="">{{__('Select')}}</option>
                                    <option value="{{STATUS_ACTIVE}}">{{__('Active')}}</option>
                                    <option value="{{INACTIVE}}">{{__('Inactive')}}</option>
                                </select>
                            </div>
                            <input type="hidden" name="id" id="id" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light close_modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-dark submit_basic"> <i class="fa fa-save"></i> {{__('Save')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>



