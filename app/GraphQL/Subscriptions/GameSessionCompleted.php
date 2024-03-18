<?php declare(strict_types=1);

namespace App\GraphQL\Subscriptions;

use Illuminate\Http\Request;
use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;
use Nuwave\Lighthouse\Subscriptions\Subscriber;

final class GameSessionCompleted extends GraphQLSubscription
{
    /** 
     * Check if subscriber is allowed to listen to the subscription. 
     * 
     * @param  Subscriber $subscriber
     * @param  Request $request
     * 
     * @return bool
     */
    public function authorize(Subscriber $subscriber, Request $request): bool
    {
        // App has no authentication
        return true;
    }

    /** Filter which subscribers should receive the subscription. */
    public function filter(Subscriber $subscriber, mixed $root): bool
    {
        // App has no authentication
        return true;
    }

    /**
     * @param  \App\Post  $root
     */
    public function resolve(mixed $root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Post
    {
        // Optionally manipulate the `$root` item before it gets broadcasted to
        // subscribed client(s).
        $root->load(['author', 'author.achievements']);

        return $root;
    }
}
