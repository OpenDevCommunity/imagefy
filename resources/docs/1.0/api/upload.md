# Imagefy API Upload Image
---

> {info} Base URI for all requests is  `https://imagefy.me/api`

### Endpoint

| Method      | URI                 | Headers
| ----------- | ------------------- |---------
| POST        |  /v1/images/upload  | x-api-key     


### URL Params

```javascript
None
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
  "url": "String"
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
