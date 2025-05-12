<script>
    let idleTime = 0;
    const timeoutSeconds = 300;

    function resetTimer() {
        idleTime = 0;
    }

    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onscroll = resetTimer;

    setInterval(() => {
        idleTime++;
        if (idleTime >= timeoutSeconds) {
            window.location.href = "/logout-timeout";
        }
    }, 1000);
</script>