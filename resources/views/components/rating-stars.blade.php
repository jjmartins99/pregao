@props(['rating' => 0, 'max' => 5])

<div class="rating-stars">
    @for ($i = 1; $i <= $max; $i++)
        @if ($i <= floor($rating))
            <i class="fas fa-star text-warning"></i>
        @elseif ($i - $rating < 1)
            <i class="fas fa-star-half-alt text-warning"></i>
        @else
            <i class="far fa-star text-warning"></i>
        @endif
    @endfor
</div>
