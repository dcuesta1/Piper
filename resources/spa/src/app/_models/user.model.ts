import {BaseModel} from './base.model';

export class User extends BaseModel{
  id: number;
  firstName: string;
  lastName: string;
  email: string;
  role: number;
  active: boolean;
  createdAt: Date;
  modifiedAt: Date;
  deletedAt: Date;

  public constructor( attr: any, toCamel = true){
    super(attr, toCamel);
  }
}
