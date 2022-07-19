#!/bin/sh
#|
exec /home/miyokichi/sbcl/sbcl-bin/bin/sbcl --core /home/miyokichi/sbcl/sbcl-bin/lib/sbcl/sbcl.core --script $0 $0 "$@"
|#

(defun print-tag (name alst closingp)
  (princ #\<)
  (when closingp
    (princ #\/))
  (princ (string-downcase name))
  (mapc (lambda (att)
	  (format t " ~a=\"~a\"" (string-downcase (car att)) (cdr att)))
	alst)
  (princ #\>))


(defmacro tag (name atts &body body)
  `(progn (print-tag ',name
		     (list ,@(mapcar (lambda (x)
				       `(cons ',(car x) ,(cdr x)))
				     (pairs atts)))
		     nil)
	  ,@body
	  (print-tag ',name nil t)))


(defmacro :html (&body body)
  `(tag html () ,@body))

(defmacro :body (&body body)
  `(tag body () ,@body))    
    


;;; output http header
(format t  "Content-Type: text/html; charset=utf-8~%~%")




;;;output 
(format t "<!DOCTYPE html>~%")
(format t "Hello! Lisp world!!~%")


