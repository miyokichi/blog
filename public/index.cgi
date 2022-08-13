#!/usr/bin/sbcl --script

;;;#|
;;;exec /home/miyokichi/sbcl/sbcl-bin/bin/sbcl --core /home/miyokichi/sbcl/sbc;;;l-bin/lib/sbcl/sbcl.core --script $0 $0 "$@"
;;;|#

;(ql:quickload)



;;; output http header
(format t  "Content-Type: text/html; charset=utf-8~%~%")




;;;output 
(format t "<!DOCTYPE html>~%")
(format t "Hello! Lisp world!!~%")


