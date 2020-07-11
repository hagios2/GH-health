@component('mail::message')
# Hello Martek, <br>

<section>

    <p>

        {{ $formInputs['message'] }}
        
    </p>

</section>



Thanks,<br>
{{ $formInputs['name'] }} <br>

<p>
    Tel:&emsp; {{ $formInputs['phone'] }}
</p>

@endcomponent
