# API

```php
$user = User::find(1);
$post = Post::find(2);

$like = $user->like($post); // Return Namest\Likeable\Like instance
$user->unlike($post); // Return true when success and false on otherwise
```
```
