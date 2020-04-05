import {User} from './user.model';
import {Deserializable} from './deserializable.model';

export class InitialLogUserData implements Deserializable{
  user: User;
  token: string;

  deserialize(input: any): this {
    Object.assign(this, input);
    this.user = new User().deserialize(input.user);
    return this;
  }
}
