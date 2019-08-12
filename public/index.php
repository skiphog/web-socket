<?php session_start(); ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Chat</title>
</head>
<div class="container">
    <ul id="box" class="list-group m-5">
        <li class="list-group-item">Первое сообщение</li>
    </ul>
    <form id="form" action="/ajax.php" method="post" class="m-5">
        <div class="form-group">
            <label for="message">Сообщение</label> <span id="writer"></span>
            <input type="text" class="form-control" name="message" id="message" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-primary">Сказать</button>
    </form>
</div>
<body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
  const ws = new WebSocket('ws://socket/ws/:80'), box = $('#box'), input = $('#message');
  let timer, sender, wtimer, send = true;

  const pingPong = () => {
    timer = setTimeout(() => {
      ws.send('{"type": "write"}');
      pingPong();
    }, 50000);
  };
  const writeble = () => {
    clearTimeout(wtimer);
    const el = document.getElementById('writer');
    el.innerText = 'Кто-то пишет текст ...';
    wtimer = setTimeout(() => {
      el.innerText = '';
    }, 5000);
  };

  ws.onopen = () => {
    pingPong();
  };
  ws.onmessage = ({data}) => {
    const response = JSON.parse(data);
    if (response.type === 'message') {
      clearTimeout(wtimer);
      document.getElementById('writer').innerText = '';
      return box.append(`<li class="list-group-item">${response.message}</li>`);
    }

    if (response.type === 'write') {
      writeble();
    }
  };

  $('#form').on('submit', function (e) {
    e.preventDefault();
    if (input.val().trim() === '') {
      return;
    }
    $.post('/ajax.php', {message: input.val()}, function () {
      input.val('');
    });
  });

  input.on('input', function (e) {
    if (send) {
      ws.send('{"type": "write"}');
      send = !send;
      setTimeout(() => {
        send = !send;
      }, 2000);
    }
  });

  /*$(window).on('focus', function () {
    console.log('focus');
  });
  $(window).on('blur', function () {
    console.log('blur');
  });*/

</script>
</body>
</html>