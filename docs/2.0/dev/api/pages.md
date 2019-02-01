# Pages

[[toc]]

## GET /api/v1/pages

`Belt\Content\Http\Controllers\Api\PagesController@index`

<ApiParamGrid :params="['perPage', 'page']" />

**Responses**

``` json
Status 200
{
    "data": [collection]
}
```

``` json
Status: 400

{
    "status": "something bad"
}
```

## POST /api/v1/pages

`Belt\Content\Http\Controllers\Api\PagesController@store`

## GET `/api/v1/pages/{page}`

`Belt\Content\Http\Controllers\Api\PagesController@show`

## DELETE `/api/v1/pages/{page}`

`Belt\Content\Http\Controllers\Api\PagesController@destroy`

## PUT `/api/v1/pages/{page}`

`Belt\Content\Http\Controllers\Api\PagesController@update`