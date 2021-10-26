@component('mail::message')
# A new post added your followed category {{ $post->category->name}}

A post titled {{ $post->title }} has been added to {{ $post->category->name }} category on your favourite web site.

@component('mail::button', ['url' => route('posts.show', $post)])
Come Check It
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
