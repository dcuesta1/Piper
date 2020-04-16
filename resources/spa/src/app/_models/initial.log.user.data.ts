import {User} from './user.model';
import {BaseModel} from './base.model';

export class InitialLogUserData extends BaseModel{
  user: User;
  token: string;
}
