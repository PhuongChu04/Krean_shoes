@extends('client.layout.layout')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Câu hỏi thường gặp</h1>

                @if($faqs->isEmpty())
                    <p>Hiện chưa có câu hỏi nào.</p>
                @else
                    <div class="accordion" id="faqAccordion">
                        @foreach($faqs as $i => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $i }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{ $i }}" aria-expanded="false"
                                        aria-controls="collapse-{{ $i }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $i }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading-{{ $i }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
