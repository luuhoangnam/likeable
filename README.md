# API

```php
$user = User::find(1);
$post = Post::find(2);

$like = $user->like($post); // Return Namest\Likeable\Like instance
$result = $user->unlike($post); // Return true when success and false on otherwise
```

```php
$user = $like->liker; // Return model that like another model
$post = $like->likeable; // Return model that was liked by another model
```

```php
$likes = $user->likes; // Return likes collection
```
