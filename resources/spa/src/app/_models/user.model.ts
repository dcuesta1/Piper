import {Deserializable} from './deserializable.model';
import {Company} from './company.model';

export class User implements Deserializable{
  id: number;
  firstName: string;
  lastName: string;
  email: string;
  role: number;
  createdAt: Date;
  modifiedAt: Date;
  deletedAt: Date;
  company: Company;

  deserialize(input: any) {
    Object.assign(this, input);
    this.company =  new Company().deserialize(input.company);
    return this;
  }
}
