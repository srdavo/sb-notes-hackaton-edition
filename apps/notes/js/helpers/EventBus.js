class EventBus {
  constructor() {
    this.events = {};
  }

  on(eventName, callback) {
    if (!this.events[eventName]) {
      this.events[eventName] = new Set();
    }
    this.events[eventName].add(callback);
  }

  off(eventName, callback) {
    if (!this.events[eventName]) return;
    this.events[eventName].delete(callback);
  }

  emit(eventName, data = null) {
    if (!this.events[eventName]) return;
    for (const callback of this.events[eventName]) {
      callback(data);
    }
  }

  clear(eventName) {
    if (this.events[eventName]) {
      this.events[eventName].clear();
    }
  }
}

export const eventBus = new EventBus();