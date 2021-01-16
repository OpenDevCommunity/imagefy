# Imagefy API Update Image Visibility
---

> {info} Base URI for all requests is  `https://imagefy.me/api`

### Endpoint

| Method      | URI                                   | Headers
| ----------- | --------------------------------------|---------
| POST        |  /v1/images/{image_id}/setvisibility  | x-api-key     


### URL Params

```text
 image_id - ID of the image to update
```

### Data Params
```json
{
  "visibility": "private | public"
}
```

> {success.fa-check} Success Response

<p> Code: 200</p>

<p>Content</p>

```json
{
  "error": "Boolean",
  "msg": "String",
}
```

> {danger} Error Response

<p> Code: 422</p>

<p>Content</p>

```json
{
  "error": "Boolean",
  "msg": "String"
}
```
