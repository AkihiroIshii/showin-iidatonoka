<div id="meet"></div>
<script src="https://meet.jit.si/external_api.js"></script>
<script>
    const domain = "meet.jit.si";
    const options = {
        roomName: "{{ $roomName }}",
        parentNode: document.getElementById("meet"),
    };
    const api = new JitsiMeetExternalAPI(domain, options);
</script>

<form method="GET" action="{{ route('meeting.join') }}">
    <input type="text" name="roomName" placeholder="会議の名前を入力">
    <button type="submit">参加</button>
</form>