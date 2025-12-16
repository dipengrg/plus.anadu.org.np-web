<div>
    <div class="page">
        <h3 class="text-center">{{ $organization['name'] }}</h3>
        <h6 class="text-center text-muted">स्थापना: {{ $organization['established_on'] }}</h6>

        <br>
        <br>

        <table>
            <tr>
                <td colspan="2">शिर्षक:</td>
            </tr>

            <tr>
                <td>मिती:</td>
                <td>स्थान:</td>
            </tr>
        </table>

        <br><br>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>क.स.</th>
                    <th>सदस्यको नाम</th>
                    <th class="text-center">ठेगाना</th>
                    <th class="text-center">उपस्थिती (√)</th>
                </tr>
            </thead>

            <tbody>
                @if($members->count())
                    @foreach($members as $member)
                        <tr>
                            <td class="text-right">{{ nepali_number(str_pad($loop->iteration,2,'0',STR_PAD_LEFT)) }}.</td>
                            <td><sup>{{ $member->title }}</sup> {{ $member->name }}</td>
                            <td class="text-center">{{ $member->address }}</td>
                            <td class="text-center">घरधुरी सदस्य / अन्य प्रतिनिधि</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">सदस्य फेला परेन।</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <br>

        <h6>नोट/कैफियत:</h6>
    </div>
</div>
