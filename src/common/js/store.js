export function saveToLocal(id, key, value) {
  let users = window.localStorage.__userstate__;
  if (!users) {
    users = {};
    users[id] = {};
  } else {
    users = JSON.parse(users);
    if (!users[id]) {
      users[id] = {};
    }
  }
  users[id][key] = value;
  window.localStorage.__userstate__ = JSON.stringify(users);
};

export function loadFromLocal(id, key, def) {
  let users = window.localStorage.__userstate__;
  if (!users) {
    return def;
  }
  users = JSON.parse(users)[id];
  if (!users) {
    return def;
  }
  let ret = users[key];
  return ret || def;
};
