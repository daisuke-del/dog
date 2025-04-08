import { Server } from 'socket.io';

const io = new Server(3001, {
  cors: { origin: '*' },
  path: '/socket.io/'
});

const rooms = {};

io.on('connection', (socket) => {
  socket.on('join', ({ room, name }) => {
    socket.join(room);
    socket.data = { room, name };
    if (!rooms[room]) rooms[room] = { pressedQueue: [], scores: {} };
    io.to(room).emit('state', rooms[room]);
  });

  socket.on('buzz', () => {
    const { room, name } = socket.data;
    const r = rooms[room];
    if (!r.pressedQueue.includes(name)) {
      r.pressedQueue.push(name);
      io.to(room).emit('state', r);
    }
  });

  socket.on('correct', () => {
    const { room } = socket.data;
    const r = rooms[room];
    const name = r.pressedQueue.shift();
    r.scores[name] = (r.scores[name] || 0) + 1;
    io.to(room).emit('state', r);
  });

  socket.on('wrong', () => {
    const { room } = socket.data;
    const r = rooms[room];
    r.pressedQueue.shift();
    io.to(room).emit('state', r);
  });

  socket.on('reset', () => {
    const { room } = socket.data;
    rooms[room].pressedQueue = [];
    io.to(room).emit('state', rooms[room]);
  });
});
