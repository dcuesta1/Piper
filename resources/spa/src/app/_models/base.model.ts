import {SnakeToCamel} from '../_etc/SnakeToCamel';

export class BaseModel {
  public constructor(attributes: any = null, toCamel = true) {
    if (attributes) {
      if (toCamel) {
        attributes = SnakeToCamel.do(attributes);
      }

      Object.assign(this, attributes);
    }
  }
}

