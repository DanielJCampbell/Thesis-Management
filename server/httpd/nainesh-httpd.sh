#!/bin/sh
#
# httpd Script starts/stops apache http server
#
APACHE_DIR=~/SWEN302/Thesis-Management/server/ # points to where the httpd directory is
APACHE_GROUP=students

export APACHE_DIR APACHE_GROUP
CONF_FILE=$APACHE_DIR/httpd/conf/httpd.conf
DESC="Apache Http Server"


case "$1" in
   start)
      echo -n "Starting ${DESC}: "
      /usr/pkg/sbin/apachectl -f $CONF_FILE -k start
      ;;
   stop)
      echo -n "Stopping ${DESC}: "
      /usr/pkg/sbin/apachectl -f $CONF_FILE -k stop
      ;;
   restart)
      echo -n "Restarting ${DESC}: "
      /usr/pkg/sbin/apachectl -f $CONF_FILE -k restart
      ;;
   *)
      echo "Usage: $0 {start|stop|restart}" >&2
      exit 1
      ;;
esac
