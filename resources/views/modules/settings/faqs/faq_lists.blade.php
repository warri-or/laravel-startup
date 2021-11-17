<div class="card-box">
    <div class="row">
        <div class="col-md-6">
            <h4 class="header-title">{{__('Faqs List')}}</h4>
            <p class="sub-header">
                {{__('Here goes the faqs list')}}
            </p>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-sm btn-dark" id="create_faq"><i class="fa fa-plus"></i> {{__('Create new')}}</button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="faqs_table" class="table table-sm table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="all text-center" width="1">{{__('Move')}}</th>
                <th>{{__('Question')}}</th>
                <th>{{__('Answer')}}</th>
                <th>{{__('Status')}}</th>
                <th>{{__('Action')}}</th>
            </tr>
            </thead>
            <tbody class="sortable"></tbody>
        </table>
    </div>
</div>
