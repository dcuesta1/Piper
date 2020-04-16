export class SnakeToCamel {
  public static do(item: any) {
    if ( SnakeToCamel.isObject(item) ) {
      const n = {};

      Object.keys(item)
        .forEach((k) => {
          n[SnakeToCamel.toCamelCase(k)] = SnakeToCamel.do(item[k]);
        });

      return n;
    } else if (Array.isArray(item)) {
      return item.map((i) => {
        return SnakeToCamel.do(i);
      });
    }

    return item;
  }

  private static isObject(obj) {
    return (obj === Object(obj) && !Array.isArray(obj) && typeof obj !== 'function');
  }

  private static toCamelCase(string: String) {
    return string.replace(/([-_][a-z])/ig, ($1) => {
      return $1.toUpperCase()
        .replace('-','')
        .replace('_','')
    });
  }
}
