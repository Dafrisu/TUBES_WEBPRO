<script>
    let idleTime = 0;
    const timeoutSeconds = 600;

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
            window.location.href = "/masuk?reason=timeout";
        }
    }, 1000);
</script>