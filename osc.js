// O - returns object
// S - returns object.style
// C - returns object by class name

function O(obj) {
  if (typeof obj == 'object') {
    return obj;
  } else {
    return document.getElementById(obj);
  }
}

function S(obj) {
  return O(obj).style;
}

function C(obj) {
  return document.getElementsByClassName(obj);
}
