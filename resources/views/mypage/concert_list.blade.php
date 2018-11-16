<div class="card">
    <div class="card-header">ライブ一覧</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        ライブ一覧だおっ!
    </div>
</div>
