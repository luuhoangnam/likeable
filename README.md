# API

```php
class User extends Model
{
    use \Namest\Likeable\LikerTrait;
}

class Post extends Model
{
    use \Namest\Likeable\LikeableTrait;
}
```

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
$posts = $user->likes; // Return likeable collection that liker was liked
$users = $post->likers; // Return liker collection who like that post
```

```php
$users = User::wasLike($post)->...->get(); // Return liker collection who like that post
$posts = Post::likedBy($user)->...->get(); // Return post collection which was liked by the user 
```

# Events

#### namest.likeable.liking

Before `$liker` like a likeable
Payloads:
- `$liker`: Who do this action
- `$likeable`: Which will be liked
Example:
```php
\Event::listen('namest.likeable.liking', function ($liker, $likeable) {
    // Do something
});
```

#### namest.likeable.liked

After `$liker` was like a likeable
Payloads:
- `$liker`: Who do this action
- `$likeable`: Which was liked
- `$like`: Like instance
Example:
```php
\Event::listen('namest.likeable.liked', function ($liker, $likeable, $like) {
    // Do something
});
```

#### namest.likeable.unliking

Before `$liker` unlike a likeable
Payloads:
- `$liker`: Who do this action
- `$likeable`: Which will be unliked
Example:
```php
\Event::listen('namest.likeable.unliking', function ($liker, $likeable) {
    // Do something
});
```

#### namest.likeable.unliked

After `$liker` was unlike a likeable
Payloads:
- `$liker`: Who do this action
- `$likeable`: Which was unliked
Example:
```php
\Event::listen('namest.likeable.unliked', function ($liker, $likeable) {
    // Do something
});
```