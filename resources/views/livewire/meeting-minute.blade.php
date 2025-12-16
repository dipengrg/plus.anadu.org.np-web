<div>
    <div class="page">
        <h3 class="text-center">{{ $organization['name'] }}</h3>
        <h6 class="text-center text-muted">स्थापना: {{ $organization['established_on'] }}</h6>

        <br>
        <br>

        <table>
            <tr>
                <td>मिती/समय:</td>
                <td>स्थान:</td>
            </tr>
        </table>

        <br>

        <p>उपरोक्त मिती, समय तथा स्थानमा अनदुका गाउलेहरु भेला भई यस् संस्थाका अध्यक्ष <strong>श्री {{ 'level1' }}</strong> ज्यू को अध्यक्षतामा प्रस्तुत प्रस्तावहरुमा छलफल गरी तपसिल बमोजिम निर्णय गरियो।</p>

        <br>

        <h5 class="text-center">(कार्यसमिती)</h5>

        <hr>
        
        <div class="row">
            <div class="col-4">
                <ul class="list-unstyled">
                    <li><strong>Post</strong> : Name</li>
                </ul>
            </div>
            <div class="col-4">
                <ul class="list-unstyled">
                    <li><strong>Post</strong> : Name</li>
                </ul>
            </div>
            <div class="col-4">
                <ul class="list-unstyled">
                    <li><strong>Post</strong> : Name</li>
                </ul>
            </div>
        </div>

        <br>

        <h5 class="text-center">(प्रस्ताव / कार्यसूची / छलफलको बिषय)</h5>

        <hr>

        <table class="table table-striped">
            <tbody>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="page">
        <h5 class="text-center">(सदस्यको उपस्थिति)</h5>
        
        <hr>
        
        <ul class="list-unstyled members">
            @if($members->count())
                @foreach($members as $member)
                    <li>
                        <div class="card p-2 text-center">
                            @if($member->photo)
                                <img class="card-img-top" src="{{ asset('storage/' . $member->photo) }}">
                            @else
                                <img class="card-img-top" src="{{ asset('img/profile.png') }}">
                            @endif

                            <div class="card-body">
                                <header>
                                    @if($member->title)
                                        <sup>{{ $member->title }}</sup><br>
                                    @endif

                                    <strong class="card-title">{{ $member->name }}</strong>
                                </header>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>

        <br>

        <h5 class="text-center">(निर्णय हरु)</h5>

        <hr>

        <table class="table table-striped">
            <tbody>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
