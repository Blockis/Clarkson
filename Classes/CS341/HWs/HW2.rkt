; Paul Burgwardt
; CS341 Programming Languages
; HW2

#lang racket
(require racket/stream)

(define file->stream 
  (lambda (filename)
    (let ((in-port (open-input-file filename)))
      (letrec
        ((build-input-stream
          (lambda ()
            (let ((ch (read-char in-port)))
              (if (eof-object? ch)
                  (begin
                    (close-input-port in-port)
                    (stream))
                  (stream-cons ch (build-input-stream)))))))
        (build-input-stream)))))

(define stream->file
  (lambda (filename str)
    (let ((out-port (open-output-file filename #:exists 'replace)))
      (letrec
          ((build-output-stream
            (lambda (str)
                (cond ((stream-empty? str)
                       (close-output-port out-port))
                      (else
                       (write-char (stream-first str) out-port)
                       (build-output-stream (stream-rest str)))))))
        (build-output-stream str)))))
                 

(define formatter 
  (lambda (input-filename output-filename line-length)
    (stream->file output-filename
      (right-justify line-length
        (remove-spaces-before-newlines             
         (insert-newlines line-length
           (remove-extra-spaces
             (remove-newlines
               (file->stream input-filename)))))))))

(define insert-newlines 
  (lambda (line-length str)
    (letrec
      ((insert 
        (lambda (str count)
	  (if (stream-empty? str)
	      str
	      (let ((n (count-chars-to-next-space str)))
	        (if (and (< count line-length) 
		         (<= (+ n count) line-length))
		    (stream-cons
		      (stream-first str)
		      (insert (stream-rest str) (+ count 1)))
		    (stream-cons
		      #\newline
		      (insert (trim-spaces str) 0))))))))
      (insert (trim-spaces str) 0))))

(define trim-spaces 
  (lambda (str)
    (cond ((stream-empty? str) (stream))
	  ((char=? (stream-first str) #\space)
	   (trim-spaces (stream-rest str)))
	  (else str))))


(define count-chars-to-next-space 
  (lambda (str)
    (letrec
      ((count-ahead
        (lambda (str count)
	  (cond ((stream-empty? str) count)
	        ((char=? (stream-first str) #\space) count)
	        (else (count-ahead (stream-rest str) (+ count 1)))))))
      (count-ahead str 0))))

(define remove-newlines
  (lambda(str)
    (cond
      ((stream-empty? str)
       str)
      ((char=? #\newline (stream-first str))
       (stream-cons #\space (remove-newlines (stream-rest str))))
      (else
       (stream-cons (stream-first str) (remove-newlines (stream-rest str)))))))

(define remove-extra-spaces
  (lambda(str)
    (cond
      ((stream-empty? str)
       str)
      ((char=? #\space (stream-first str))
       (stream-cons #\space (remove-extra-spaces (remove-extra-spaces-helper (stream-rest str)))))
      (else
       (stream-cons (stream-first str) (remove-extra-spaces (stream-rest str)))))))

(define remove-extra-spaces-helper
  (lambda (str)
    (cond
      ((stream-empty? str)
       str)
      ((char=? #\space (stream-first str))
       (remove-extra-spaces-helper (stream-rest str)))
      (else
       str))))

(define right-justify
  (lambda (line-length str)
    (letrec
      ((justify
        (lambda (start rest)
          (cond ((stream-empty? rest)
                 start)
                ((<= (stream-length start) line-length)
                 (justify (justify-line start (stream-length start) line-length) rest))
                (else
                 (stream-append start (right-justify line-length rest)))))))
         (justify (get-stream-line str) (stream-tail str (stream-length (get-stream-line str)))))))
      
 
(define get-stream-line
  (lambda (str)
    (cond
      ((stream-empty? str)
       str)
      ((char=? #\newline (stream-first str))
        (stream-cons #\newline empty-stream))
      (else
       (stream-cons (stream-first str) (get-stream-line (stream-rest str)))))))


(define justify-line
  (lambda (line counter line-length)
     (cond (( not (<= counter line-length))
       line)
     ((stream-empty? line)
      empty-stream)
     ((char=? #\space (stream-first line))
      (stream-cons (stream-first line) (stream-cons #\space (justify-line (stream-rest line) (+ 1 counter) line-length))))
     (else
      (stream-cons (stream-first line) (justify-line (stream-rest line) counter line-length))))))

(define remove-spaces-before-newlines
  (lambda (str)
    (cond ((stream-empty? str)
           empty-stream)
          ((char=? #\space (stream-first str))
           (cond ((and (> (stream-length str) 2) (char=? #\newline (stream-ref str 1)))
                  (remove-spaces-before-newlines (stream-rest str)))
                 (else
                  (stream-cons (stream-first str) (remove-spaces-before-newlines (stream-rest str))))))
          (else
           (stream-cons (stream-first str) (remove-spaces-before-newlines (stream-rest str)))))))
  