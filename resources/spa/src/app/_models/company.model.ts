import {Deserializable} from './deserializable.model';

export class Company implements Deserializable{
  id: number;
  name: string;
  phone: number;
  email: string;

  deserialize(input: any): this {
    Object.assign(this, input);
    return this;
  }
}
