import Pusher from "pusher-js";
import Echo from "laravel-echo";

class EchoQuasar{

  constructor(){
    this.echo = new Echo({
      broadcaster:process.env.BROADCAST_DRIVER,
      key: process.env.PUSHER_APP_KEY,
      cluster: process.env.PUSHER_APP_CLUSTER,
      encrypted: process.env.PUSHER_APP_ENCRYPTED,
    });
  }

  channel(channel='global'){
    this.echo.channel(channel)
  }

  listen(channel, event){
    this.echo.listen(channel, event)
  }

}

const echo = new EchoQuasar();

export default echo;

export {echo}
