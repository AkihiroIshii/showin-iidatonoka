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
