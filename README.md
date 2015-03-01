# Setting Started

Provide an _elegant way_ to interact with like feature between your eloquent models.

**Note**: Package only support Laravel 5

# Installation

**Step 1**: Install package
```bash
composer require namest/likeable
```

**Step 2**: Register service provider in your `config/app.php`
```php
return [
    ...
    'providers' => [
        ...
        'Namest\Likeable\LikeableServiceProvider',
    ],
    ...
];
```

**Step 3**: Publish package resources, include: configs, migrations. Open your terminal and type:
```bash
php artisan vendor:publish --provider="Namest\Likeable\LikeableServiceProvider"
```

**Step 4**: Migrate the migration that have been published
```bash
php artisan migrate
```

**Step 5**: Use some trait to make awesome things
```php
class User extends Model
{
    use \Namest\Likeable\LikerTrait;
    
    // ...
}

class Post extends Model
{
    use \Namest\Likeable\LikeableTrait;
    
    // ...
}
```

**Step 6**: Read API below and start _happy_

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
Usage:
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
Usage:
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
Usage:
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
Usage:
```php
\Event::listen('namest.likeable.unliked', function ($liker, $likeable) {
    // Do something
});
```