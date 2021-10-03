@section('contentFields')
    <div style="margin-top: 1rem; text-align: center; font-style: italic;">
        @if (empty($item->current_template_value))
            <div>
                Template is not set.
            </div>

            <div style="margin-top: 0.5rem;">
                Make sure to add the <b>template</b> field to your model's <b>$fillable</b> property<br>
                or create a default form template: <b>resources/views/admin/{{$moduleName}}/_default.blade.php</b>
            </div>
        @else
            <div>
                Form template not found for <b>{{ $item->current_template_value }}</b>.
            </div>

            <div style="margin-top: 0.5rem;">
                Add your form template by creating the following file:
                <b>resources/views/admin/{{$moduleName}}/_{{ $item->current_template_value }}.blade.php</b><br>
                or create a default form template: <b>resources/views/admin/{{$moduleName}}/_default.blade.php</b>
            </div>
        @endif
    </div>
@stop
