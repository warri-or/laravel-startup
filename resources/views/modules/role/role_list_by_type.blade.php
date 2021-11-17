@if(isset($routes) && !empty($routes))
    @foreach($routes as $route)
        <option value="{{$route->id}}" {{in_array($route->id, $role_action) ? 'selected': ''}}>{{$route->name}}</option>
    @endforeach
@endif
