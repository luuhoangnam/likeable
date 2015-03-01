# API

```php
class User 
{
    use \Namest\Likeable\LikerTrait;
}

class Post
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
